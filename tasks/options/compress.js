module.exports = {
	main: {
		options: {
			mode: 'zip',
			archive: './release/vcaddons.<%= pkg.version %>.zip'
		},
		expand: true,
		cwd: 'release/<%= pkg.version %>/',
		src: ['**/*'],
		dest: 'vcaddons/'
	}
};