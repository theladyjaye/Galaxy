//
//  GalaxyCommand.h
//  iPhone_GalaxyClientCore
//
//  Created by Adam Venturella on 1/23/10.
//  Copyright 2010 __MyCompanyName__. All rights reserved.
//

#import <Foundation/Foundation.h>

extern NSString * const kGalaxyMethodGet;
extern NSString * const kGalaxyMethodPost;
extern NSString * const kGalaxyMethodPut;
extern NSString * const kGalaxyMethodDelete;

@interface GalaxyCommand : NSObject {
	NSString     * contentType;
	NSString     * content;
	NSString     * endpoint;
	NSString     * method;
	SEL callback;
}


@property(nonatomic, retain) NSString * method;
@property(nonatomic, retain) NSString * endpoint;
@property(nonatomic, retain) NSString * content;
@property(nonatomic, retain) NSString * contentType;
@property(nonatomic, assign) SEL callback;

- (void) prepareCommand;
- (void) setContentType:(NSString *)value;
- (void) setContent:(NSString *)value;
@end
